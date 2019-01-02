# Gitlab Watcher
Watching (self-hosted) Gitlab merge requests status, and notifying the members that haven't seen.

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
