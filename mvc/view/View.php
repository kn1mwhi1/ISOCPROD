<?php 
class View {
    private $model;
    private $controller;
    
    public function __construct(Controller $controller, Model $model) {
        $this->controller = $controller;
        $this->model = $model;
    }
    
    public function output() {
        return '<a href="mvc.php?action=textclicked">' . $this->model->text . '</a>';
    }
}
?>
