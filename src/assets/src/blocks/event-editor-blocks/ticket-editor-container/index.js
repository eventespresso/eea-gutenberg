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
import TicketEditorContainer from './container';

export default () => registerBlockType(
    'ee-event-editor/ticket-editor-container',
    {
        title: 'Event Espresso Ticket Editor',
        icon: 'list-view',
        category: 'common',
        keywords: ['ticket', 'datetime', 'registration'],
        supports: {
            html: false
        },
        useOnce: true,
        edit: TicketEditorContainer,
        save() {
            return null;
        }
    }
);