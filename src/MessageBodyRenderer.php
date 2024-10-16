<?php

declare(strict_types=1);

namespace Yiisoft\Mailer\View;

use Yiisoft\Mailer\MessageInterface;
use Yiisoft\View\Exception\ViewNotFoundException;
use Yiisoft\View\View;

/**
 * View renderer used to compose message body.
 *
 * @api
 */
final class MessageBodyRenderer
{
    /**
     * @param View $view The view instance.
     * @param MessageBodyTemplate $template The message body template instance.
     */
    public function __construct(
        private View $view,
        private MessageBodyTemplate $template,
    ) {
    }

    /**
     * Returns a new instance with the specified view.
     *
     * @param View $view The view instance.
     *
     * @return self The new instance.
     */
    public function withView(View $view): self
    {
        $new = clone $this;
        $new->view = $view;
        return $new;
    }

    /**
     * Returns a new instance with the specified message body template.
     *
     * @param MessageBodyTemplate $template The message body template.
     *
     * @return self The new instance.
     */
    public function withTemplate(MessageBodyTemplate $template): self
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    /**
     * Returns a new instance with specified locale code.
     *
     * @param string $locale The locale code.
     */
    public function withLocale(string $locale): self
    {
        $new = clone $this;
        $new->view = $this->view->withLocale($locale);
        return $new;
    }

    /**
     * Adds the rendered body to the message and returns it.
     *
     * @param MessageInterface $message The message to which the body will be added.
     * @param string $htmlView The view name to be used for rendering the message HTML body.
     * @param array $viewParameters The parameters (name-value pairs) that will be extracted and available in
     * the view file.
     * @param array $layoutParameters The parameters (name-value pairs) that will be extracted and available in
     * the layout file.
     * @param string|null $textView The view name to be used for rendering the message text body.
     *
     * @throws ViewNotFoundException If the view file does not exist.
     * @return MessageInterface The message with the added body.
     */
    public function addBodyToMessage(
        MessageInterface $message,
        string $htmlView,
        array $viewParameters = [],
        array $layoutParameters = [],
        ?string $textView = null,
    ): MessageInterface {
        $message = $message->withHtmlBody(
            $this->renderHtml($htmlView, $viewParameters, $layoutParameters)
        );

        if ($textView !== null) {
            $message = $message->withTextBody(
                $this->renderText($textView, $viewParameters, $layoutParameters)
            );
        }

        return $message;
    }

    /**
     * Renders the HTML view specified with optional parameters and layout.
     *
     * @param string $view The view name of the view file.
     * @param array $viewParameters The parameters (name-value pairs) that will be extracted and available in
     * the view file.
     * @param array $layoutParameters The parameters (name-value pairs) that will be extracted and available in
     * the layout file.
     *
     * @see View::render()
     *
     * @throws ViewNotFoundException If the view file does not exist.
     * @return string The rendering HTML result.
     */
    public function renderHtml(string $view, array $viewParameters = [], array $layoutParameters = []): string
    {
        $content = $this->view
            ->withContextPath($this->template->viewPath)
            ->render($view, $viewParameters);

        if ($this->template->htmlLayout === null) {
            return $content;
        }

        $layoutParameters['content'] = $content;
        return $this->view
            ->withContextPath($this->template->viewPath)
            ->render($this->template->htmlLayout, $layoutParameters);
    }

    /**
     * Renders the text view specified with optional parameters and layout.
     *
     * @param string $view The view name of the view file.
     * @param array $viewParameters The parameters (name-value pairs) that will be extracted and available in
     * the view file.
     * @param array $layoutParameters The parameters (name-value pairs) that will be extracted and available in
     * the layout file.
     *
     * @see View::render()
     *
     * @throws ViewNotFoundException If the view file does not exist.
     * @return string The rendering text result.
     */
    public function renderText(string $view, array $viewParameters = [], array $layoutParameters = []): string
    {
        $content = $this->view
            ->withContextPath($this->template->viewPath)
            ->render($view, $viewParameters);

        if ($this->template->textLayout === null) {
            return $content;
        }

        $layoutParameters['content'] = $content;
        return $this->view
            ->withContextPath($this->template->viewPath)
            ->render($this->template->textLayout, $layoutParameters);
    }
}
