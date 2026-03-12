import React from 'react';
import * as FaIcons from 'react-icons/fa';

export const SidebarData = [
    {
        title: 'Livros',
        path: '/livros',
        icon: <FaIcons.FaBook   />,
        cName: 'nav-text'
    },
    {
        title: 'Autores',
        path: '/autores',
        icon: <FaIcons.FaUserEdit   />,
        cName: 'nav-text'
    },
    {
        title: 'Assuntos',
        path: '/assuntos',
        icon: <FaIcons.FaTags  />,
        cName: 'nav-text'
    },
];