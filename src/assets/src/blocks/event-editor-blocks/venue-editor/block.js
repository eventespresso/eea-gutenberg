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
import { VenueEdit, VenuePreview } from './components';


export default class VenueBlock extends Component {
    constructor() {
        super( ...arguments );
    }
    render() {
        const { attributed, setAttributes, isSelected } = this.props;
        const inspectorControls = isSelected && (
            <InspectorControls key={"inspector-ticket-editor"}>
                <h3>{ 'Global Settings related to the Venue Block' }</h3>
                <p>
                    { 'In this panel will be any settings related to the entire event for the context of the Venue.'}
                </p>
            </InspectorControls>
        );
        const content = isSelected
            ? <VenueEdit key="venue-block"/>
            : (
                <Placeholder key="placeholder">
                    <VenuePreview />
                </Placeholder>
            );
        return [
            inspectorControls,
            content
        ];
    }
};
