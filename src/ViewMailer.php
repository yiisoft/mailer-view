<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View;

use Yiisoft\Mailer\MailerInterface;
use Yiisoft\Mailer\Message;
use Yiisoft\Mailer\MessageInterface;
use Yiisoft\Mailer\SendResults;
use Yiisoft\View\Exception\ViewNotFoundException;

/**
 * Mailer decorator with extra method `compose()` for composing message body via view rendering.
 *
 * @api
 */
final class ViewMailer implements MailerInterface
{
    /**
     * @param MailerInterface $mailer The mailer.
     * @param MessageBodyRenderer $messageBodyRenderer View renderer for compose message body.
     */
    public function __construct(
        private readonly MailerInterface $mailer,
        private MessageBodyRenderer $messageBodyRenderer,
    ) {
    }

    /**
     * Returns a new instance with the specified message body template.
     *
     * @param MessageBodyTemplate $template The message body template instance.
     *
     * @return self The new instance.
     */
    public function withTemplate(MessageBodyTemplate $template): self
    {
        $new = clone $this;
        $new->messageBodyRenderer = $new->messageBodyRenderer->withTemplate($template);
        return $new;
    }

    /**
     * Returns a new instance with specified locale code.
     *
     * @param string $locale The locale code.
     *
     * @return self
     */
    public function withLocale(string $locale): self
    {
        $new = clone $this;
        $new->messageBodyRenderer = $new->messageBodyRenderer->withLocale($locale);
        return $new;
    }

    /**
     * Creates a new message instance and optionally composes its body content via view rendering.
     *
     * @param string|null $htmlView The view name to be used for rendering the message HTML body.
     * @param array $viewParameters The parameters (name-value pairs) that will be extracted and available in
     * the view file.
     * @param array $layoutParameters The parameters (name-value pairs) that will be extracted and available in
     * the layout file.
     * @param string|null $textView The view name to be used for rendering the message text body. If `null`, the text
     * body will be generated by strip tags in HTML body.
     *
     * @throws ViewNotFoundException If the view file does not exist.
     * @return MessageInterface The message instance.
     */
    public function compose(
        ?string $htmlView = null,
        array $viewParameters = [],
        array $layoutParameters = [],
        ?string $textView = null,
    ): MessageInterface {
        $message = new Message();

        if ($htmlView === null) {
            return $message;
        }

        return $this->messageBodyRenderer->addBodyToMessage(
            $message,
            $htmlView,
            $viewParameters,
            $layoutParameters,
            $textView,
        );
    }

    public function send(MessageInterface $message): void
    {
        $this->mailer->send($message);
    }

    public function sendMultiple(array $messages): SendResults
    {
        return $this->mailer->sendMultiple($messages);
    }
}
