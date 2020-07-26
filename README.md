# What is this.

docker-compose bundle for simple Wordpress theme.


# Usage

On the working-machine, Clone this repo into project dir.
Then remove .git directory.

    cd /your/app/dir
    git clone REPO-URL .
    rm -rf .git


On the working-machine, Prepare your .env file.
And set your own info.

    cp .env.default .env
    vi .env

Make or put your Certification file.

    mkcert localhost 127.0.0.1


Then, build up the container.

    docker-compose up


Thats it.
