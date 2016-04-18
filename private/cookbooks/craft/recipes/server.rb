# Cookbook Name:: craft
# Recipe:: server
#
# Copyright (c) 2016 Creditcards.com, All Rights Reserved.

# Write the apache vhost entry for CMS.
template "/etc/httpd/sites-available/craft.conf" do
  source 'craft.conf.erb'
  owner 'root'
  group 'root'
  mode 0644
  notifies :restart, 'service[apache2]', :delayed
  variables(
      :webroot_location => node['craft']['webroot_location'],
      :server_name => node['craft']['server_name']
      )
end

# Enable Site
apache_site 'craft' do
  enable true
end