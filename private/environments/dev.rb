name "dev"
description "The dev environment"

cookbook_versions(
)

default_attributes(
  "datadog" => {
    "tags" => "dev"
  }
)

override_attributes(
)
