#RBF Automation Web Service

###Requirements
 - LAMP (Linux, Apache, MySQL, PHP)

###Structure
    /conf
        - Mater control panel
    /reference
        - Contains SQL schema and other resources
    /api
        - web API consumed by the clients (Android app)

###Setup
 - Create MySQL database from ``/reference/db.sql` - name it whatever you want
 - copy `SQLConnect.php.example` to `SQLConnect.php` and fill in the SQL connection information
 - You may need to change some `.htaccess` rules based on your subnet settings


###SSL Notes
The android client by default requires SSL. If you plan to use this to serve the Android app, you must either create or obtain and SSL cert and key. Setting this up is outside the scope of this guide. 
