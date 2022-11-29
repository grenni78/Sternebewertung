import { usePage } from "@inertiajs/inertia-vue3";

import { helpers, API_URL } from "./helpers";

/**
 * helper_cast_json_data
 *
 * casts json values to the right type
 */
const cast_json_data = (data) => {
    const cast = (arr) => {
        arr.id = Number(arr.id);
        arr.sender_id = Number(arr.sender_id);
        arr.recipient_id = Number(arr.recipient_id);
        arr.pinned = Number(arr.pinned);
        arr.unread = Number(arr.unread);
    };

    if (Array.isArray(data)) {
        data.forEach((el, idx) => {
            cast(data[idx]);
        });
    } else {
        cast(data);
    }
    return data;
};

/**
 * api_send_message
 *
 * sends message to the server
 * returns promise
 */
const send_message = async (message, recipient) => {
    return helpers.new_async_promise(async () => {
        const { data } = await window.axios.post(
            `${API_URL}messages`,
            {
                message: message,
                sender: usePage().props.value?.userDetails?.id,
                recipient: recipient,
            },
            {
                transformResponse: cast_json_data,
                responseType: "json",
            }
        ); // .post

        return data;
    });
}; // send_message

/**
 * mark_read_message
 * param value boolean     should message be marked as read
 * param messageId integer message id
 */
const mark_read_message = (value, messageId) => {
    return helpers.new_async_promise(async () => {
        const { data } = await window.axios.post(
            `${API_URL}messages/mark-read`,
            {
                id: messageId,
                read: value,
                userId: usePage().props.value?.userDetails?.id,
            },
            {
                responseType: "json",
            }
        );

        return data;
    });
};
/**
 * get_messages
 *
 * returns all messages for the currently logged in user
 */
const get_messages = () => {
    return helpers.new_async_promise(async () => {
        const { data } = await window.axios.get(`${API_URL}messages`, {
            responseType: "json",
            transformResponse: cast_json_data,
        });
        return data;
    });
};

/**
 * gets a single message
 */
const get_message = (id) => {
    return helpers.new_async_promise(async () => {
        const { data } = await window.axios.get(`${API_URL}message/${id}`, {
            responseType: "json",
            transformResponse: cast_json_data,
        });
        return data;
    });
};

export { get_message, get_messages, mark_read_message, send_message };
