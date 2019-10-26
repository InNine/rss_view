
##Specifications:
php7.1+, mysql5.7+
##to start project
use console commands:

From root: \
`composer install` \
`php init` (choose production) 
>then go to *common/config/main-local.php* and change db credits to yours

`php yii migrate` (to apply db changes)

`php yii parse` (to parse data) 

To start server set domain root directory to *frontend/web* \
Or use command from (*/frontend/web*): `php -S localhost:8000`

##Info about files

**Common server logic** is in (*/common/domain*) 

**Parse logic** in (*console/services*) and controller is in (*console/controllers*) 

**Client logic** (vue) is in (*/frontend/vue*). 
>To have ability to compile - use command from (*/frontend*): `npm install`  \
>To compile - use command from (/frontend): `npm run production` (or `npm run watch`)

**Styles** are in (*/frontend/web/scss*) 
>To compile them use command from (*/frontend/gulp*): `gulp watch`
