<?php
require_once('php/preprocessors.php');

function do_preprocess($type_name, $data) {
	$type = Spyc::YAMLLoad('types/' . $type_name . '.yaml');
	if (array_key_exists('preprocess', $type) && is_callable($type['preprocess'])) {
		return $type['preprocess']($data);
	} else {
		return $data;
	}
}

function preprocess($name, $fields, $def) {
	foreach ($def['fields'] as $name => $data) {
		if ($data['type'] == 'component') {
			foreach ($data['fields'] as $sub_name => $sub_data) {
				if (array_key_exists('default', $sub_data) && !array_key_exists($sub_name, $fields[$name])) {
					$fields[$name][$sub_name] = $sub_data['default'];
				} else if (!array_key_exists($sub_name, $fields[$name])) {
					throw new Exception('Required field "' . $sub_name . '" not found');
				}
				$fields[$name][$sub_name] = do_preprocess($sub_data['type'], $fields[$name][$sub_name]);
			}
		} else if ($data['type'] == 'component-array') {
			for ($i = 0; $i < count($fields[$name]); $i++) {
				foreach ($data['fields'] as $sub_name => $sub_data) {
					if (array_key_exists('default', $sub_data) && !array_key_exists($sub_name, $fields[$name][$i])) {
						$fields[$name][$i][$sub_name] = $sub_data['default'];
					} else if (!array_key_exists($sub_name, $fields[$name][$i])) {
						throw new Exception('Required field "' . $sub_name . '" not found');
					}
					$fields[$name][$i][$sub_name] = do_preprocess($sub_data['type'], $fields[$name][$i][$sub_name]);
				}
			}
		} else {
			if (array_key_exists('default', $data) && !array_key_exists($name, $fields)) {
				$fields[$name] = $data['default'];
			} else if (!array_key_exists($name, $fields)) {
				throw new Exception('Required field "' . $name . '" not found');
			}
			$fields[$name] = do_preprocess($data['type'], $fields[$name]);
		}
	}

	return $fields;
}
