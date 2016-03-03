<?php

namespace Rudivdme\BearContent\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
	/**
	 * Get rules populated with data
	 *
	 * @param  string $type Must be declared as variable in the model
	 * @param  array  $data Array of data used to populate the rules
	 * @return array        The modified array of rules
	 */
    public function getRules($type, $data=[])
    {
        $rules = $this->{$type."Rules"};

        foreach ($rules as $ix => &$rule)
        {
            foreach ($data as $key => $value)
            {
                $rule = str_replace("{".$key."}", $value, $rule);
            }
        }

        return $rules;
    }

    /**
     * Parse rules with data, array of rules given
     *
     * @param  array  $rules Array of rules
     * @param  array  $data  Array of data used to populate the rules
     * @return array         The modified array of rules
     */
    public function parseRules(array $rules, array $data)
    {
        foreach ($rules as $ix => &$rule)
        {
            foreach ($data as $key => $value)
            {
                $rule = str_replace("{".$key."}", $value, $rule);
            }
        }

        return $rules;
    }

    /**
     * Filter rules by fields_only field
     *
     * @param  object  $request  Request object
     * @param  array   $rules    Array of rules
     * @return array             The modified array of rules
     */
    public function filterRules($request, array $rules)
    {
        if ($request->has('fields_only'))
        {
            $arr = [];

            foreach (explode(',', $request->input('fields_only')) as $field)
            {
                foreach ($rules as $f => $rule)
                {
                    if (substr($f, 0, strlen($field)) == $field)
                    {
                        $arr[$f] = $rules[$f];
                    }
                }
            }

            return $arr;
        }

        return $rules;
    }

    /**
     * Filter input in given request by the fields_only field
     *
     * @param  object $request The request object
     * @return array           The array of filtered input fields
     */
    public function getFilteredInput($request)
    {
        $input = $request->all();

        if ($request->has('fields_only'))
        {
            $arr = [];

            foreach (explode(',', $request->input('fields_only')) as $field)
            {
                if (array_has($input, $field))
                {
                    array_set($arr, $field, array_get($input, $field) );
                }
            }

            return $arr;
        }

        return $input;
    }
}
