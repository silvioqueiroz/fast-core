<?php
require_once FAST_PATH . '/core/AdvancedAction.class.php';

class Pagenotfound extends AdvancedAction
{

    private $empresaDAO;

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function process()
    {
        $this->setPage("pagenotfound");
        // $this->empresaDAO = new EmpresaDAO();
        // $enterprise = $_GET["enterprise"];
        // $img = $this->empresaDAO->getImagemEmpresa(getNomeEmpresa($enterprise));
        // $this->imagem_top = "img/$img";
        // $this->left = "Página não encontrada!";
        //
        // $this->image_middle = "img/top1.jpg";
    }
}

?>