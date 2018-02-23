/**
 * External imports
 */
import React from 'react';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import 'react-tabs/style/react-tabs.css';

/**
 * Internal Imports
 */
import RegistrationFormEditor from '../registration-form-block';
import TicketEditor from './block';

export function TicketEditorBlock(props) {
    return (
        <Tabs defaultIndex={0} onSelect={index => console.log(index)}>
            <TabList>
                <Tab>Edit Tickets/Datetimes</Tab>
                <Tab>Edit Registration Form</Tab>
            </TabList>
            <TabPanel>
                <TicketEditor />
            </TabPanel>
            <TabPanel>
                <RegistrationFormEditor />
            </TabPanel>
        </Tabs>
    )
}


export function TicketSelector(props) {
    return (
        <div>
            <h3>Ticket Selector For Event</h3>
            <p>
                In this view, event authors can get a preview of the ticket selector of the event from the details they
                added via the editor and also move the block around to position where they want the selector in the content.
            </p>
        </div>
    );
}