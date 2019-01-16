# csv-loader
[![Latest Version](https://img.shields.io/github/release/portphp/portphp.svg?style=flat-square)](https://github.com/jtotty/csv-loader/releases)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jtotty/csv-loader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jtotty/csv-loader/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/jtotty/csv-loader/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jtotty/csv-loader/build-status/master)

Parses data from a CSV file. 

This is a specific utility tool for [SpeechLink Multimedia Ltd.](https://speechandlanguage.info/)

Requires development in the application in which this is installed to work properly.

## Functionality
- Removes blank rows of data left behind by csv software *(Eg: MS Excel likes to leave cells as empty strings).
- Mapping column names.
- Checks validity of names.
- Fix date formats to UK.
- Converts yes/no user inputs to correct values.

## Built With

* [PortPHP](https://portphp.readthedocs.io/en/latest/) - Data import/export workflow for PHP

## Authors

* **James Totty** - *Developer* - [Jtotty](https://github.com/jtotty)
