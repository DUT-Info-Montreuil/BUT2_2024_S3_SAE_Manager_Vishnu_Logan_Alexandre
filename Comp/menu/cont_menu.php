<?php
    include_once 'vue_menu.php';
    class ControllerMenu{
        private $vue;

        public function __construct(){
            $this->vue=new VueMenu();
            $this->vue->prepareMenu();


        }

        public function afficherMenu(){
            $this->vue->renderMenu();
        }
    }


?>