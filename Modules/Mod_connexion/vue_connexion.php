
<?php
require_once 'vue_generique.php';

class VueConnexion extends VueGenerique {

    public function __construct() {
        parent::__construct();
    }



    public function form_inscription() {
        $csrf_token = $this->getCSRFToken();
        echo "
        <div class='login-container'>
            <form class='login-form' action='index.php?module=connexion&action=inscription' method='post'>
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
                            <option value='enseignant'>Enseignant</option>
                            <option value='etudiant'>Étudiant</option>
                            <option value='intervenant'>Intervenant</option>
                        </select>
                    </div>
                    <button type='submit' class='btn'>S'inscrire</button>
                    <a href='index.php?module=connexion&action=connexion'>Déjà inscrit ?</a>
                </fieldset>
            </form>
        </div>
        </body>";
    }
    
    

    public function form_connexion() {
        $csrf_token = $this->getCSRFToken();
        echo "
        <div class='login-container'>
            <form class='login-form' action='index.php?module=connexion&action=connexion' method='post'>
                <input type='hidden' name='csrf_token' value='$csrf_token'>
                <fieldset class='fieldset'>
                    <h1>Connexion</h1>

                    <div class='input-group'>
                        <input type='text' name='login' placeholder='Nom d’utilisateur' required>
                    </div>
                    <div class='input-group'>
                        <input type='password' name='mot_de_passe' placeholder='Mot de passe' required>
                    </div>
                    
                    <div class='remember-me'>
                        <input type='checkbox' name='remember' id='remember'>
                        <label for='remember'>Se souvenir de moi</label>
                    </div>
                    <button type='submit' class='btn'>Se connecter</button>
                   <a href='index.php?module=connexion&action=inscription'>Pas inscrit ?</a>
                </fieldset>
            </form>
        </div>
        </body>";
    }

    public function confirmation_ajout() {
        echo '<div class="message-success">L\'utilisateur a bien été ajouté !</div>';
    }

    public function confirmation_connexion() {
        echo '<div class="message-success">Connexion réussie !</div>';
    }
    public function confirmation_deconnexion() {
        echo '<div class="message-success">Déconnexion réussie !</div>';
    }

    public function afficher(): string {
        return $this->getAffichage();
    }
 

    private function getCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
    }
}
?>
