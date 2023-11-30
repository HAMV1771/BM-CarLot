import React from 'react';
import './App.css';
import { RouterProvider, createBrowserRouter } from 'react-router-dom';
import Dashboard from './views/Dashboard';
import { ChakraProvider, Container } from '@chakra-ui/react';

export const API_URL = "http://bluemedical-carlot.lan/api";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Dashboard />
  }
])

function App() {
  return (
    <ChakraProvider>
        <RouterProvider router={router} />
    </ChakraProvider>
  );
}

export default App;
