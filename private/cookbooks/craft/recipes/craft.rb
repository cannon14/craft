#
# Cookbook Name:: craft
# Recipe:: craft
#
# Copyright (c) 2016 Creditcards.com, All Rights Reserved.

directory node['craft']['webroot_location'] do
  recursive true
  owner node['webroot_owner']
  group node['webroot_group']
  mode '0775'
  action :create
end

# Write .bashrc for user
template "/home/vagrant/.bashrc" do
  source '.bashrc.erb'
  owner 'root'
  group 'root'
  mode 0644
end

