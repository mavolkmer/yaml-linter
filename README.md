# yaml-linter
Wrapper for symfony/yaml's LintCommand ([see Symfony/Yaml](https://symfony.com/doc/current/components/yaml.html#syntax-validation))

Call it like Symfony's LintCommand with `filename` as arguments, single files as `exclude`-Option and with additional option `excludePattern`.  
ExcludePattern are parsed with symfony/finder ([see Symfony/Finder](https://symfony.com/doc/current/components/finder.html)) as path and all matching `yaml|yml` are added to LintCommand's exclude-options.

## use-case
In some projects one might use local composer-packages which have their own frontend-buildchain. This buildchain might integrate some third-party libraries into your project-structure with malformed `yaml`-files which you don't need to care for.  
```bash
├── composer.json
├── src
…
└── packages
    └── local-subpackage
        ├── composer.json
        ├── Configuration
        ├── Documentation
        ├── Resources
        │   ├── node_modules
        │   │   ├── some third party npm-packages
        │   │   └── …
        │   ├── package.json
        │   ├── Sources
        │   ├── webpack.config.js
        │   └── yarn.lock
        …

```

When scanning this whole project with a `yaml-lint`-command I got some errors from node_modules-subdirectories. You should for sure validate those error-messages, create several pull-requests to the third-party repos, patch your local files while waiting for pr to be merged - but to be honest in real life you only need a "green pipeline".

## Example
```
vandor/bin/yaml-linter src --excludePattern=thirdParty
```
