set :deploy_to, "/home/staging/"

server 'copra-system.de', user: 'lukas', roles: %w{web app db}