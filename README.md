##Tourism On Net

Project Started on September 7, 2015, 3:22 pm.

This concept for 

#Setting Up

#Entities


Country
Category
SubCategory
FurtherDetails
Photo
Video

setting up database
run : php app/console doctrine:database:drop --force
    : php app/console doctrine:database:create
    : php app/console doctrine:schema:update --force

1. First Create an admin using fos user bundle command line tool 
    run : php app/console fos:user:create adminuser --super-admin
2. Now start the the server
    run : php app/console server:run
3. Before anythin you have to setup categories. ! Be careful...Choose the 'Code' of the category in a way that it is a unique for each category.
4. Then create countires. Remember to add a uniqe code for each country(Follow international conventions). Add one or more categories to country from the 'Categories Menu' by selecting multiple categories using 'CTRL' key.
5. Now you can setup sub-categories for countries. There must be at least one sub category for each country to start to upload photos/videos. Therefor create a sub category named 'general' for each country.
You should use HTML to add the description field.
6. For each sub category you can add a further details section.
7. Now users can upload photos and videos to available countries, categories and sub categories.

8. apache config
- sudo apt-get install libapache2-mod-php5
-php app/console cache:clear --env=prod --no-debug
-sudo chmod -R 777 app/cache app/logs
-a2ensite tourismonnet.conf



References
==========

login modal : http://formvalidation.io/examples/modal/
Entity as an input : http://symfony.com/doc/current/reference/forms/types/entity.html
Easy admin bundle Integration : http://level7systems.co.uk/en/more-with-easyadminbundle/
Using Easy admin with fos user bundle : https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Resources/doc/tutorials/customizing-admin-controller.md
Download Assets : http://www.99bugs.com/controller-action-for-file-download-link-in-symfony2/
Hidden Field Types : http://symfony.com/doc/current/reference/forms/types/hidden.html
Dynamic Forms : https://www.adayinthelifeof.nl/2014/03/19/dynamic-form-modification-in-symfony2/
               : http://showmethecode.es/php/symfony/symfony2-4-dependent-forms/
               :http://devlog.rolandow.com/2014/11/symfony-forms-dependent-selectboxes/


<li>http://symfony.com/doc/current/bundles/FOSUserBundle/command_line_tools.html</li>
