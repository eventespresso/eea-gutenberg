/**
 * External Dependencies
 */
import React from 'react';

/**
 * WordPress dependencies
 */
const { registerBlockType } = wp.blocks;

/**
 * Internal Dependencies
 */
import EventListBlock from './block.js';

export default () => registerBlockType(
    'ee-shortcodes/events-list',
    {
        title: 'Event Espresso Event List',
        icon: 'list-view',
        category: 'widgets',
        keywords: [ 'events', 'recent events' ],
        supports: {
            html: false
        },
        edit: EventListBlock,
        save() {
            return null;
        }
    }
);