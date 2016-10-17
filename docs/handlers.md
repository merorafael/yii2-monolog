Handlers
========

The logger has a stack of handlers, and each can be used to write the log entries to different 
locations (e.g. files, database, Slack, etc).

List of handlers
----------------

| Handler          | Documentation                       | Array structure | Object structure |  
| ---------------- | ----------------------------------- | --------------- | ---------------- |
| stream           | **Not Implemented**                 | Yes             | Yes              |
| firephp          | **Not Implemented**                 | Yes             | Yes              |
| browser_console  | **Not Implemented**                 | Yes             | Yes              |
| gelf             | **Not Implemented**                 | Yes             | Yes              |
| chromephp        | **Not Implemented**                 | Yes             | Yes              |
| rotating_file    | **Not Implemented**                 | Yes             | Yes              |
| yii_db           | [Implemented](handler/yii_db.md)    | Yes             | Yes              |
| yii_mongo        | [Implemented](handler/yii_mongo.md) | Yes             | Yes              |
| hipchat          | **Not Implemented**                 | Yes             | Yes              |
| slack            | **Not Implemented**                 | Yes             | Yes              |
| elasticsearch    | **Not Implemented**                 | No              | Yes              |
| fingers_crossed  | **Not Implemented**                 | No              | Yes              |
| filter           | **Not Implemented**                 | No              | Yes              |
| buffer           | **Not Implemented**                 | No              | Yes              |
| deduplication    | **Not Implemented**                 | No              | Yes              |
| group            | **Not Implemented**                 | No              | Yes              |
| whatfailuregroup | **Not Implemented**                 | No              | Yes              |
| syslog           | **Not Implemented**                 | Yes             | Yes              |
| syslogudp        | **Not Implemented**                 | Yes             | Yes              |
| swift_mailer     | **Not Implemented**                 | No              | Yes              |
| socket           | **Not Implemented**                 | Yes             | Yes              |
| pushover         | **Not Implemented**                 | No              | Yes              |
| raven            | **Not Implemented**                 | No              | Yes              |
| newrelic         | **Not Implemented**                 | No              | Yes              |
| cube             | **Not Implemented**                 | No              | Yes              |
| amqp             | **Not Implemented**                 | No              | Yes              |
| error_log        | **Not Implemented**                 | No              | Yes              |
| null             | **Not Implemented**                 | No              | Yes              |
| test             | **Not Implemented**                 | No              | Yes              |
| debug            | **Not Implemented**                 | No              | Yes              |
| loggly           | **Not Implemented**                 | No              | Yes              |
| logentries       | **Not Implemented**                 | No              | Yes              |
| flowdock         | **Not Implemented**                 | No              | Yes              |
| rollbar          | **Not Implemented**                 | No              | Yes              |

**Note:** Documents not added can be accessed in the 
[Monolog official documentation](https://github.com/Seldaek/monolog/blob/master/doc/02-handlers-formatters-processors.md#handlers).
