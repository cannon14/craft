name "base"
description "base role applied to all nodes"

run_list=[
  "recipe[build-essential]",
  "recipe[sysctl::apply]",
  "recipe[ulimit]",
  "recipe[timezone-ii]",
  "recipe[users::sysadmins]",
  "recipe[sudo]",
  "recipe[ntp]",
  "recipe[sysstat]",
  "recipe[zip]",
  "recipe[htop]",
  "recipe[selinux::disabled]",
]

env_run_lists(
  "_default" => [],
  "production" => run_list,
  "dev" => run_list,
  "staging" => run_list
)

default_attributes(
  "authorization" => {
    "sudo" => {
      "include_sudoers_d" => true
    }
  },
  "build-essential" => {
    "compile_time" => true
  },
  "opsline-chef-client" => {
    "unregister_at_shutdown" => true
  },
  "opsline-hostname" => {
    "domain" => "creditcards.com"
  },
  "sysctl" => {
    "params" => {
      "fs" => {
        "file-max" => "65536"
      }
    }
  },
  "tz" => "Etc/UTC",
  "cc" => { 
    "nfs-server" => '20.20.100.20'
   }
)

override_attributes(
)

