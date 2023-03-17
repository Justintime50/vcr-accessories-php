<?php

use VCR\VCR;
use VCRAccessories\CassetteSetup;

const CASSETTE_DIR = 'tests/cassettes';
CassetteSetup::setupCassetteDirectory(CASSETTE_DIR);

VCR::configure()->setCassettePath(CASSETTE_DIR)
    ->setStorage('yaml')
    ->setMode('once');
