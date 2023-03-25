# yaml-linter
Wrapper for symfony/yaml's LintCommand

Call it like Symfony's LintCommand with fileiname as arguments, single files as `exclude`-Option and with additional option `exlucePattern`.  
ExcludePattern are parsed with symfony/finder as path and all matching `yaml|yml` are added to LintCommand's exclude-options.

## Example
```
vandor/bin/yaml-linter src -excludePattern=thirdParty
```

