#
# Cookbook Name:: craft
# Recipe:: default
#
# Copyright (c) 2016 Creditcards.com, All Rights Reserved.

include_recipe 'yum'
include_recipe 'yum-remi'
include_recipe "apache2::default"
include_recipe "apache2::mod_php5"
include_recipe "apache2::mod_ssl"
include_recipe "apache2::mod_rewrite"
include_recipe "apache2::mod_access_compat"
include_recipe "mongodb::default"
include_recipe "craft::server"
include_recipe "craft::database"
include_recipe "craft::php"
include_recipe "craft::packages"
include_recipe "craft::craft"
