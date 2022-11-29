const API_MAJOR = 1;
const API_MINOR = 1;
const API_VERSION = `${API_MAJOR}.${API_MINOR}`;
const API_URL = "/api/v1_1/";

/**
 * helper_error_handler
 *
 * handles axios errors
 */
const error_handler = (error) => {
    if (error.response) {
        console.error(
            error.response.data,
            error.response.status,
            error.response.statusText
        );
    }

    if (error.request) {
        console.error(
            "Request was made, but got no answer from server.",
            error.request
        );
    }
};
/**
 * returns a new Promise with an ansynchronus handler
 */
const new_async_promise = (handler) => {
    return new Promise((resolve, reject) => {
        (async () => {
            try {
                const data = await handler();

                resolve(data);
            } catch (error) {
                error_handler(error);

                reject(error);
            }
        })();
    });
};

const helpers = { error_handler, new_async_promise };

export { helpers, API_MAJOR, API_MINOR, API_VERSION, API_URL };
