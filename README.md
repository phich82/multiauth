# Push on Github & Bitbucket at same time
    1 - Push on github
        As normal
    2 - Push on bitbucket:
        git remote add origin https://phich82@bitbucket.org/phich82/multiauth.git
        git push bitbucket master (if added [git add .], committed [git commit -m], then only use this command)

# Pull from Github & Bitbucket
    git pull github your_branch
    git pull bitbucket your_branch

# Create bitbucket repo from github repo
    1 - Create a new github repo (on github.com)
        > git init
        > git add .
        > git commit -m "first commit"
        > git remote add origin https://github.com/phich82/jwtauth.git (from github.com)
        > git push -u origin master
    2 - Push github on bitbucket
        > Create a new bitbucket repo (on bitbucket.org)
        > git remote add bitbucket https://phich82@bitbucket.org/phich82/jwtauth.git (from bitbucket.org)
            => At here, you can enter username/password if required
        > git push bitbucket master

# Color for log when run Tests
    phpunit TestS --colors=always | cat
