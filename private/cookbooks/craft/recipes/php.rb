#
# Cookbook Name:: craft
# Recipe:: php
#
# Copyright (c) 2016 Creditcards.com, All Rights Reserved.

# Install the PHP PDO module
package 'php-pdo' do
    notifies :restart, 'service[apache2]', :delayed
end

# Install the PHP MySql module
package 'php-mysql' do
    notifies :restart, 'service[apache2]', :delayed
end

# Install the PHP Dom module
package 'php-dom' do
    notifies :restart, 'service[apache2]', :delayed
end

# Install the PHP Dom module
package 'php-gd' do
    notifies :restart, 'service[apache2]', :delayed
end

# Install the PHP Soap module
package 'php-soap' do
    notifies :restart, 'service[apache2]', :delayed
end
