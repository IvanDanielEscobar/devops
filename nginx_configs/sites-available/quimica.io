server {
    listen 0.0.0.0:80;
    listen [::]:80;

    # This specifies the domain name(s) your server will respond to.
    # Replace brand.com with your actual domain.
    server_name quimica.io; 

    # This sets the document root for your website.
    root /var/www/quimica.io/html;

    # This specifies the default files Nginx should look for when a directory is requested.
    index index.html; 

    # This location block handles requests for files and directories.
    location / {
        try_files $uri $uri/ =404;
    }

    # You might add other location blocks for specific purposes, like:
    # - Handling PHP files (if you're using PHP-FPM)
    # - Setting up redirects
    # - Caching static assets
	location ~ /\.ht {
		deny all;
	}
}
