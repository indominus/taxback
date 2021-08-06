# TaxBack
TaxBack task implementation

# Install

clone repository

``git clone https://github.com/indominus/taxback``

run composer install 

```composer install```

copy and edit config.ini file

```cp config.ini.sample config.ini```

import pgsql 

```psql taxback < taxback.sql```

run project
```php -S 0.0.0.0:8000```

# Run Sync Command for import author's books 

```php console.php```
