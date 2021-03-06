#!/usr/bin/env bash


# Shared vars start ----------------------------------------------------------------
VENDOR_BIN_PATH="vendor/bin/"






# Shared methods start -------------------------------------------------------------
# Confirm prompt
function confirm() {

    local description=${1}
    local default=${2}
    local prompt="[y/N]"
    local response=default

    if [ "$default" = "Y" ]; then
        prompt="[Y/n]"
    else
        default="N"
    fi

    # assign std input to the keyboard and close it again after retrieving the response
    exec < /dev/tty
    read -r -p "${description} ${prompt} " response
    exec <&-

    if [ "$response" = "" ]; then
        response=${default}
    fi

    if [[ "$response" = "Y" ]] || [[ "$response" = "y" ]]; then
        result="Y"
    else
        result="N"
    fi

    echo ${result}
}






# PSR-2 standard syntax in PHP files start -----------------------------------------
# GET GIT REVISION TO CHECK AGAINST
EMPTY_TREE=$(git hash-object -t tree /dev/null > /dev/null)
GIT_REV=$(git rev-parse --verify HEAD)

if [ "$GIT_REV" = "" ]; then
    AGAINST="$EMPTY_TREE"
else
    AGAINST="$GIT_REV"
fi

# GET MODIFIED PHP FILES
PHPFILES=$(git diff-index --cached --name-only --diff-filter=ACRM "$AGAINST" | egrep "\.php$")

# PHP Code sniffer validator
function validatePhpCodingStandardAndSniffs() {

    echo -e "\033[0;33mChecking coding standards...\033[0m"
    local valid=true

    for file in ${1}; do
        if ! ${VENDOR_BIN_PATH}phpcs --colors --standard=PSR2 ${file}; then
            echo -e "Coding standard check failed, but I can try to fix this:"
            if [ $(confirm "Would you like to fix this automatically?") = "Y" ]; then
                $(${VENDOR_BIN_PATH}phpcbf --standard=PSR2 ${file})
                echo -e "\033[0;33mFile ${file} has been modified, please add it again and re-try the commit\033[0m"
            fi
            valid=false
        fi
    done

    return $([ "$valid" = true ] && echo 0 || echo 1)
}

if ! validatePhpCodingStandardAndSniffs ${PHPFILES}; then
    if [ $(confirm "PHP Coding standard failed. Continue?") = "N" ]; then
        fail "Check PHP coding standard and code sniffs and try again."
    fi
fi







# PHPUnit tests start --------------------------------------------------------------
PHPUNIT_TESTS_PATH="tests/unit"
PHPUNIT_CONFIG_FILE="phpunit.xml"

# PHPUnit tests
function validatePhpUnit() {

    echo -e "\033[0;33mChecking unit tests...\033[0m"
    local valid=true

    if ! ${VENDOR_BIN_PATH}phpunit --configuration=${PHPUNIT_CONFIG_FILE} ${PHPUNIT_TESTS_PATH}; then
        valid=false
    fi

    return $([ "$valid" = true ] && echo 0 || echo 1)
}

if ! validatePhpUnit; then
    fail "PHP Unit tests failed"
fi

