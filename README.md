# locatie-informatie
Website to get location info, based on a zipcode or a cityname.

# Setup

To setup a basic installation:

# Load the fixtures
# Run the SQL script
# run php app/console location:convert:sql 
# run php app/console location:convert:cbs
# run php app/console location:convert:corrections
# run php app/console location:convert:check

Between 'php app/console location:convert:sql'  and 'php app/console location:convert:cbs' you must wait a while to make sure the beanstalk workers has done the dob of converting the first fase.
