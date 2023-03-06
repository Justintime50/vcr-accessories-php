<?php

namespace VCRAccessories;

class CassetteScrubber
{
    /**
     * Scrub sensitive information from cassette files prior to persisting them to disk.
     *
     * @param array $scrubbers
     * @param mixed $data
     * @return mixed
     */
    public static function scrubCassette(array $scrubbers, mixed $data): mixed
    {
        if (isset($data)) {
            foreach ($scrubbers as $scrubber) {
                $key = $scrubber[0];
                $replacement = $scrubber[1];

                // Root-level list scrubbing
                if (self::isList($data)) {
                    foreach ($data as $index => $item) {
                        if (is_array($index)) {
                            if (is_array($item)) {
                                if (array_key_exists($key, $item)) {
                                    $data[$index][$key] = $replacement;
                                }
                            }
                        }
                    }
                } else {
                    // Root-level key scrubbing
                    if (is_array($data)) {
                        if (array_key_exists($key, $data)) {
                            $data[$key] = $replacement;
                        } else {
                            // Nested scrubbing
                            foreach ($data as $index => $item) {
                                if (is_array($item)) {
                                    if (self::isList($item)) {
                                        foreach ($item as $nestedIndex => $nestedItem) {
                                            $data[$index][$nestedIndex] = self::scrubCassette($scrubbers, $nestedItem);
                                        }
                                    } elseif (!self::isList($item)) {
                                        $data[$index] = self::scrubCassette($scrubbers, $item);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Check if input is a list (eg: sequential array).
     *
     * PHP treats JSON objects (associative arrays) and lists (sequential arrays) as the
     * same thing (array), this function is used to determine what kind of array something is.
     *
     * @param array $array
     * @return bool
     */
    protected static function isList(array $array): bool
    {
        if (!is_array($array)) {
            return false;
        }

        foreach (array_keys($array) as $key) {
            if (!is_numeric($key)) {
                return false;
            }
        }

        return true;
    }
}
