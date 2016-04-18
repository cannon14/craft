#
# Cookbook Name:: craft
# Recipe:: database
#
# Copyright (c) 2016 Creditcards.com, All Rights Reserved.

mysql_client 'default' do
  action :create
end

mysql_service 'default' do
  port '3306'
  version '5.5'
  initial_root_password 'password'
  socket '/var/lib/mysql/mysql.sock'
  action [:create, :start]
end

mysql2_chef_gem 'default' do
  action :install
end

mysql_database node['database']['name'] do
  connection(
    :host     => '127.0.0.1',
    :username => 'root',
    :password => 'password'
  )
  action :create
end


mysql_database_user node['database']['username'] do
  connection(
    :host     => '127.0.0.1',
    :username => 'root',
    :password => 'password'
  )

  password node['database']['password']
  database_name node['database']['name']
  host 'localhost'

  action [:create,:grant]
end

