/**
 * Admin helper functions.
 *
 * @package Creode Blocks
 */
const AdminHelpers = {
	/**
	 * Performs a deep compare on two objects and executes a callback function
	 * if any object property doesn't match.
	 *
	 * @param {Object} originalObj - The original object to compare.
	 * @param {Object} newObj - The new object to compare against.
	 * @param {Function} callback - Callback function executed when differences are found.
	 *                               Receives (path, originalValue, newValue) as arguments.
	 *                               If original value is primitive, newValue can be object/array.
	 * @param {string} pathPrefix - Internal parameter for building the property path.
	 * @returns {void}
	 */
	deepCompare(originalObj, newObj, callback, pathPrefix = '') {
		// Get all unique keys from both objects
		const allKeys = new Set([
			...Object.keys(originalObj || {}),
			...Object.keys(newObj || {})
		]);

		// Handle arrays
		if (Array.isArray(originalObj) || Array.isArray(newObj)) {
			const originalArray = Array.isArray(originalObj) ? originalObj : [];
			const newArray = Array.isArray(newObj) ? newObj : [];
			const maxLength = Math.max(originalArray.length, newArray.length);

			for (let i = 0; i < maxLength; i++) {
				const arrayPath = pathPrefix ? `${pathPrefix}[${i}]` : `[${i}]`;
				const originalValue = originalArray[i];
				const newValue = newArray[i];

				// If index doesn't exist in one array
				if (i >= originalArray.length) {
					callback(arrayPath, undefined, newValue);
				} else if (i >= newArray.length) {
					callback(arrayPath, originalValue, undefined);
				}
				// If both are objects/arrays, recurse
				else if (this.isObjectOrArray(originalValue) && this.isObjectOrArray(newValue)) {
					this.deepCompare(originalValue, newValue, callback, arrayPath);
				}
				// If original is primitive and new is object/array, or vice versa, or both primitives differ
				else if (originalValue !== newValue) {
					callback(arrayPath, originalValue, newValue);
				}
			}
			return;
		}

		// Handle objects
		allKeys.forEach(key => {
			const currentPath = pathPrefix ? `${pathPrefix}.${key}` : key;
			const originalValue = originalObj?.[key];
			const newValue = newObj?.[key];

			// Check if key exists in both objects
			const originalHasKey = originalObj && originalObj.hasOwnProperty(key);
			const newHasKey = newObj && newObj.hasOwnProperty(key);

			// If key doesn't exist in one of the objects, treat as difference
			if (!originalHasKey && newHasKey) {
				callback(currentPath, undefined, newValue);
				return;
			}

			if (originalHasKey && !newHasKey) {
				callback(currentPath, originalValue, undefined);
				return;
			}

			// If both are objects or arrays, recurse
			if (this.isObjectOrArray(originalValue) && this.isObjectOrArray(newValue)) {
				this.deepCompare(originalValue, newValue, callback, currentPath);
			}
			// If original is primitive and new is object/array, or vice versa, or both primitives differ
			else if (originalValue !== newValue) {
				callback(currentPath, originalValue, newValue);
			}
		});
	},

	/**
	 * Check if a value is a primitive (string, number, boolean, null, undefined).
	 *
	 * @param {any} value - The value to check.
	 * @returns {boolean} - True if the value is a primitive.
	 */
	isPrimitive(value) {
		return value === null || 
			value === undefined || 
			typeof value === 'string' || 
			typeof value === 'number' || 
			typeof value === 'boolean';
	},

	/**
	 * Check if a value is an object or array.
	 *
	 * @param {any} value - The value to check.
	 * @returns {boolean} - True if the value is an object or array.
	 */
	isObjectOrArray(value) {
		return value !== null && 
			value !== undefined && 
			typeof value === 'object';
	}
};

