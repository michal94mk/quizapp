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
        extract($this->data); // Extracts data array to variables
        ob_start(); // Start output buffering
        include $this->viewPath;
        return ob_get_clean(); // Get buffered content
    }

    public function render() {
        $content = $this->renderView(); // Prepare the content of the view
        $layoutData = $this->data;        // Prepare data for layout scope
        $layoutData['content'] = $content;

        if ($this->layoutPath) {
            extract($layoutData); // Extract data array to variables for layout
            include $this->layoutPath; // Include the layout file
        } else {
            echo $content; // Output content directly if no layout is provided
        }
    }
}