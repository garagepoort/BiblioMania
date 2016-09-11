### Installation
To run js-tests karma has to be installed. This can be done with following commands.

    npm install karma jasmine-core karma-jasmine phantomjs --save-dev
    npm install karma-phantomjs-launcher --save-dev

### Running tests

    karma start --single-run --browsers PhantomJS karma.conf.js