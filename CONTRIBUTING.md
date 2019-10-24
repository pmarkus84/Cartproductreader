# Contributing

* Strictly follow the code-guidelines PSR-2 in document "PSR-2-coding-guidlines.md"
* Use certain tags in commit messages.
    * [BUGFIX] Change a Bug, but not behavior or code style
    * [CLEANUP] Remove Files or Code that are not used anymore
    * [FEATURE] Add new Feature (e.g. new button, new action)
    * [UPDATE] update dependencies and code interacting with dependencies
    * [SECURITY] Fix an security issue by updating a module/package or fix in the own code
    * [PREPARATION] e.g. Add a new dependency, file or directive that does not have an effect, yet.
    * [TEST] Add/fix/alter tests
    * [CODESTYLE] Fix code style violation, reorder entries, but must not change any code or comment
    * [COMMENT] Add/fix/alter comments in the code
    * [DOCS] Add/fix/alter documentation
    * [REFACTOR] Extract code to methods/variables, simplify code. Must not change behavior.
    * [TASK] Alter fixed data like constants or labels, but not code
    * [API] Change visibility of methods or fields, private <> protected <> public
    * [TYPO] Fix a typo in exception or error messages not related to behaviour
    * [META] Add/alter/update metadata like keywords, authors, mails and URLs
    * [GIT] Change git related stuff like ignores
    * [DEV] Add files required for development like .editorconfig or dynamicReturnTypeMeta.json, Build toolchains etc.
    * [DEPRECATION] Deprecation of functions, methods and classes
    * [LOGS] Add logger, increase log verbosity. Does not alter behaviour!
* Keep the documents up to date with changes.
* Include the copyright notice in new files.
* Don´t alter your name in existing copyright notice if you didn´t add new code.

## This Copyright notice must include in all PHP files
Replace the `|TAG|` with your information.

```
/*
 * Copyright (C) |CURRENTYEAR| pm-webdesign.eu
 * |FIRST_NAME| |LAST_NAME| <|YOUR_EMAIL|>
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */
