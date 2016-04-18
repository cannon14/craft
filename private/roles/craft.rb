name "craft"
description "The role to setup the Craft CCCOM."

run_list=[
  "role[base]",
  "recipe[craft]"
]

env_run_lists(
  "_default" => [],
  "production" => run_list,
  "dev" => run_list,
  "staging" => run_list
)

default_attributes(
   "apache" => {
    "version" => "2.4",
    "listen_ports" => ["80", "8080"]
  }
)

override_attributes(
)
