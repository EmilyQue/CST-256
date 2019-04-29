<nav class="navbar navbar-light navbar-expand-md navigation-clean-search">
        <div class="container"><a class="navbar-brand" href="start">LopeConnect</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse"
                id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="profile">Profile</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Groups</a>
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="groupList">Join A Group</a><a class="dropdown-item" role="presentation" href="userGroup">My Groups</a></div>
                    </li>
                    
                    <?php if(session()->has('role')) {
                        if (session('role') == 1) {                
                    ?>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Admin</a>
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="usersAdmin">Users</a><a class="dropdown-item" role="presentation" href="jobAdmin">Job Posts</a><a class="dropdown-item" role="presentation" href="groupsAdmin">Groups</a>
                            <div class="dropdown-divider" role="presentation"></div><a class="dropdown-item" role="presentation" href="jobPosting">Create A Job Post</a><a class="dropdown-item" role="presentation" href="groups">Create A Group</a></div>
                    </li>
                </ul>
                <?php                         
                    }}?>
                <form action="search" class="form-inline mr-auto" target="_self">
                    <div class="form-group"><label for="search-field"><i class="fa fa-search"></i></label><input class="form-control search-field" type="search" name="search" id="search-field" placeholder="Search..."></div>
                </form>
                
                <?php if (session()->has('user_id')) {
                    echo "<div class='btn btn-light'>Welcome " . session()->get('username') . "<a href='logout'> Logout</a></div>";
                } else {?>
                
                <a class="btn btn-light action-button" role="button" href="login" style="padding: 8px 20px;margin: 9px;"><i class="fa fa-user"></i>&nbsp;Login</a><a class="btn btn-light action-button" role="button" href="register"><i class="fa fa-user-plus"></i>&nbsp;Register</a></div>
      </div>
      <?php }?>
        
    </nav>
    <script src="resources/assets/js/jquery.min.js"></script>
    <script src="resources/assets/bootstrap/js/bootstrap.min.js"></script>