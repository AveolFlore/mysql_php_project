<header>
    <nav>
        <div class="nav-left">
            <a href="/">Home</a>
            <?php if(isset($_SESSION['user'])):?>
            <a href="page-etudiant">Étudiants</a>
            <a href="page-cours">Cours</a>
            <a href="page-room">Salles</a>
            <a href="page-contact">Contact</a>
            <?php endif; ?>
        </div>
        <div class="nav-right">
            <?php if(isset($_SESSION['user'])):?>
            <a href="page-profil">Profil</a>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/page-auth">Utilisateurs</a>
                <?php endif; ?>
            <a href="/auth-logout">Déconnexion</a>
            <?php else: ?>
                <a href="/page-login">Connexion</a>
            <?php endif; ?>
        </div>
    </nav>
</header>