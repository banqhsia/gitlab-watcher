# Gitlab Watcher
Watch Gitlab merge requests and notify the members who haven't seen, or when it's ready to merge.

![](https://i.imgur.com/ylTxKi4.png)


## Installation
1. Clone the repository.
2. Install Composer dependencies.
    ```
    composer install
    ```
3. Set up environment variables.
    ```
    cp .env.example .env
    ```
    and edit it.

4. Run the application.
    ```
    ./gitlab-watcher
    ```

## `.env` file
| Environment variable | Description
|---|---|
|PRIVATE_TOKEN | Gitlab personal private token.
|SLACK_CHANNEL | Where to broadcast. Slack webhook url.
|GITLAB_BASE_URI | Gitlab base url. For example, `https://gitlab.your-company.com`. (No trailing slash)
|REDIS_HOST | Redis host.
|REDIS_PORT | Redis port. Must be set even if it's still `6379`.
|REDIS_PREFIX | Redis key prefix.
|WATCHING_PROJECTS | **IID** of watching projects (comma seperated). For example: `37,46,60`.
|MEMBERS | Your team members (comma-seperated). For example: `ben,alan,judy`
