/**
 * External dependencies
 */
import React from 'react';

/**
 * WordPress dependencies
 */
const { decodeEntities } = wp.utils;

export default function Event( { event } ) {
    return <React.Fragment>
        <li>
            <a href={event.link} target="_blank">{ decodeEntities( event.EVT_name.trim() ) || 'Untitled' }</a>
        </li>
    </React.Fragment>
}
