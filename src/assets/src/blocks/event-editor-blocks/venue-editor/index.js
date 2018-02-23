/**
 * External Dependencies
 */
import React from 'react';

/**
 * WordPress dependencies;
 */
const { registerBlockType } = wp.blocks;

/**
 * Internal Dependencies
 */
import VenueBlock from './block';

export default () => registerBlockType(
    'ee-event-editor/venue-container',
    {
        title: 'Venue',
        icon: 'list-view',
        category: 'common',
        keywords: ['venue'],
        supports: {
            html: false
        },
        useOnce: true,
        edit: VenueBlock,
        save() {
            return null;
        }
    }
);