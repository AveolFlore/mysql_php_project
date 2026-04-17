<header>
    
    <nav>
        <a href="/">Home</a>
        <?php if(isset($_SESSION['user'])):?>
        <a href="page-etudiant">Etudiant</a>
        <a href="page-cours">Cours</a>
        <a href="page-contact">Contact</a>
        <a href="page-profil">Profil</a>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/page-auth">Users</a>
            <?php endif; ?>
        <a href="/auth-logout">Logout</a>

        <?php else: ?>
            <a href="/page-login">Login</a>
        <?php endif; ?>
    </nav>
</header>