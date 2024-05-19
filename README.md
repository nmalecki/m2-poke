# Poke API Pokemon module for Magento 2

## Summary
This module is a simple integration of the [PokeAPI](https://pokeapi.co/) into Magento 2. It allows you to search for a Pokémon by name and view its details on the PLP/PDP.\
The pokemon details are displayed basing on the Pokémon's name which you can set on the product's attribute - `Pokemon Name`.

## Installation
```
composer config repositories.poke-pokemon git https://github.com/nmalecki/m2-poke.git
composer require poke/module-pokemon
php bin/magento module:enable Poke_Pokemon
php bin/magento setup:upgrade
```
## Usage
### Configuration
Go to `Stores > Configuration > Poke API`.\
In the `Poke API Configuration` section, you can set the base URL of the PokeAPI. By default, it is set to `https://pokeapi.co/api/v2/`. \
![Poke API](https://raw.githubusercontent.com/nmalecki/m2-poke/main/docs/poke_api_config.png)
To manage Pokemon Details, go to `Pokemon Details` section. You can enable/disable displaying Pokemon details on the product page and product listing page.\
Here you can also set life time of the cache.
![Pokemon Details](https://raw.githubusercontent.com/nmalecki/m2-poke/main/docs/pokemon_details_config.png)

The module is enabled by default - once a pokemon's name is set on a product it will be displayed in the storefront.

### Error Handling
If there is any issue while fetching Pokémon data, the information will be displayed in the storefront.
You can also find more details in the log file - `var/log/pokemon_error.log`
