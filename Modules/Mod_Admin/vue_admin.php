

<?php
require_once 'vue_generique.php';

class VueAdmin extends VueGenerique {
    private $vueAccueil;
    public function __construct() {
        parent::__construct();
        $this->vueAccueil = new VueAccueil();
        $this->vueAccueil->afficherAccueil();
    }


    public function form_inscription() {
            $csrf_token = $this->getCSRFToken();
            echo "
            <div class='login-container'>
                <form class='login-form' action='index.php?module=admin&action=inscription' method='post'>
                    <input type='hidden' name='csrf_token' value='$csrf_token'>
                    <fieldset class='fieldset'>
                        <h1>Inscription</h1>
        
                        <div class='input-group'>
                            <input type='text' name='nom' placeholder='Nom' required>
                        </div>
                        <div class='input-group'>
                            <input type='text' name='prenom' placeholder='Prénom' required>
                        </div>
                        <div class='input-group'>
                            <input type='text' name='login' placeholder='Nom d’utilisateur' required>
                        </div>
                        <div class='input-group'>
                            <input type='password' name='mot_de_passe' placeholder='Mot de passe' required>
                            <input type='password' name='confirm_mot_de_passe' placeholder='Confirmer le Mot de passe' required>
                        </div>
                        <div class='input-group'>
                            <select name='role' required>
                                <option value='etudiant'>Étudiant</option>
                                <option value='enseignant'>Enseignant</option>
                                <option value='intervenant'>Intervenant</option>
                            </select>
                        </div>
                        <button type='submit' class='btn'>inscrire</button>

                    </fieldset>
                </form>
            </div>
            </body>";
        }

        private function getCSRFToken() {
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
        }


}

?>