# CHANGELOG

## v0.2.1 (2023-09-01)

- Fixes an incorrect type for the `array` parameter of `isList` which didn't allow for mixed types even though that's the purpose of the function

## v0.2.0 (2023-03-29)

- Gets the VCR cassette directory from VCR instead of needing it from the user, fixes a bug where this would double nest directories when supplied by the user

## v0.1.0 (2023-03-29)

- Initial release
  - Scrub cassette data
  - Warn or error on expired cassettes
  - Setup and teardown cassette tests
  - Setup cassette directory
