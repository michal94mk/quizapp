<?php

namespace App\View;

class View {
    private $viewPath;
    private $layoutPath;
    private $data = [];

    public function __construct($viewPath, $layoutPath = null) {
        $this->viewPath = $viewPath;
        $this->layoutPath = $layoutPath;
    }

    public function with($data) {
        $this->data = $data;
        return $this;
    }

    private function renderView() {
        extract($this->data);
        ob_start();
        include $this->viewPath;
        return ob_get_clean();
    }

    public function render() {
        $content = $this->renderView();
        $layoutData = $this->data;
        $layoutData['content'] = $content;

        if ($this->layoutPath) {
            extract($layoutData);
            include $this->layoutPath;
        } else {
            echo $content;
        }
    }
}
