default['craft']['remi']['enabled'] = true
default['yum']['remi-php55']['enabled'] = true

default['craft']['server_name'] = 'craft.creditcards.com'
default['craft']['webroot_location'] = '/var/www/html/craft'
default['craft']['server_admin'] = 'david.cannon@creditcards.com'


default['webroot_owner'] = 'apache'
default['webroot_group'] = 'apache'

default['database']['name'] = 'craft'
default['database']['username'] = 'dba'
default['database']['password'] = 'dba'

default['craft']['environment'] = 'development'

default['apache']['version'] = 2.4