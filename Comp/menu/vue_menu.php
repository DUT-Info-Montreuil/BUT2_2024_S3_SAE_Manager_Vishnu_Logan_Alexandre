<?php
    class VueMenu{
        private $menu;

  

        public function prepareMenu(){

            $this->menu='<nav>
                            <ul>
                                <li><a href="index.php?module=connexion&action=menu">Connexion</a></li>
                            </ul>
                        </nav>';
        }

        public function renderMenu(){
            echo $this->menu;
        }
    }


?>