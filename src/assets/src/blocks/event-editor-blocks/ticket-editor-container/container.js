/**
 * External imports
 */
import React from 'react';

/**
 * WordPress imports
 */
const { Component } = wp.element;
const { Placeholder } = wp.components;
const { InspectorControls } = wp.blocks;

/**
 * Internal Imports
 */
import { TicketSelector, TicketEditorBlock } from './ticket-editor-block';


export default class TicketEditorContainer extends Component {
    constructor() {
        super( ...arguments );
    }
    render() {
        const { attributed, setAttributes, isSelected } = this.props;
        const inspectorControls = isSelected && (
            <InspectorControls key={"inspector-ticket-editor"}>
                <h3>{ 'Global Settings related to Tickets/Datetimes' }</h3>
                <p>
                    { 'In this panel will be any settings related to the entire event for the context of the Ticket Editor.'}
                </p>
            </InspectorControls>
        );
        const content = isSelected
            ? <TicketEditorBlock key="ticket-editor-block"/>
            : (
                <Placeholder key="placeholder">
                    <TicketSelector />
                </Placeholder>
            );
        return [
            inspectorControls,
            content
        ];
    }
};
