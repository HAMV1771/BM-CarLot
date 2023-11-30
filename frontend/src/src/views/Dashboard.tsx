import React, { useEffect, useState } from "react";
import { Box, Button, Card, Center, Divider, Input, InputGroup, InputLeftAddon, List, ListItem, VStack } from "@chakra-ui/react";
import { FaSearch } from "react-icons/fa";
import axios from "axios";
import { API_URL } from "../App";

const Dashboard = () => {
  const [query, setQuery] = useState("");
  const [vehicles, setVehicles] = useState([]);
  const [visitVehicles, setVisitVehicles] = useState([]);

  useEffect(() => {
    fetchActiveVisitantEntries();
  }, []);

  const handleSearchSubmit = async (e:any) : Promise<void> => {
    e.preventDefault();

    const results = await axios.get(`${API_URL}/search?q=${query}`);

    setVehicles(results.data);
  }

  const fetchActiveVisitantEntries = async () : Promise<void> => {
    const results = await axios.get(`${API_URL}/visits`);

    setVisitVehicles(results.data.entries);
  }

  const handleCheckIn = async (vehicleId:number) : Promise<void> => {
    try {
      await axios.post(`${API_URL}/log`, {
        "vehicle_id": vehicleId 
      });

      setQuery("");
      setVehicles([]);

      fetchActiveVisitantEntries();
    } catch ( e:any ) {
      console.log(e);
    }
  }

  const handleCheckOut = async (vehicleId:number) : Promise<void> => {
    try {
      await axios.put(`${API_URL}/log/${vehicleId}`);

      fetchActiveVisitantEntries();
    } catch ( e:any ) {
      console.log(e);
    }
  }

  return (
    <Center w="100vw" h="100vh">
      <Card p={5}>
        <VStack w="600px">
          <Box w="100%">
            <form
              onSubmit={handleSearchSubmit}
            >
              <InputGroup  w="100%">
                <InputLeftAddon
                  children={<FaSearch />}
                />
                <Input
                  type='text'
                  placeholder='Buscar vehiculo'
                  onChange={(e:any) => { setQuery(e.target.value); }}
                  value={query}
                />
              </InputGroup>
            </form>
          </Box>
          <Box w="100%">
            <List w="100%">
              {
                vehicles.map((vehicle:any, vehicleIndex:number) => (
                  <ListItem key={`vehicle-item-${vehicleIndex}`} style={{display: 'flex'}}>
                    <span style={{display: 'flex', flex: 1}}>{vehicle.license_plate_no}</span>
                    <Button
                      onClick={() => {handleCheckIn(vehicle.id);}}
                    >
                      Registar Entrada
                    </Button>
                  </ListItem>
                ))
              }
            </List>
          </Box>
          <Divider />
          <Box w="100%">
            <List w="100%">
              {
                visitVehicles.map((entry:any, entryIndex:number) => {
                  const entryDate = Date.parse(entry.entryAt);
                  const date = new Date();
                  const now_utc = Date.UTC(date.getUTCFullYear(), date.getUTCMonth(),
                    date.getUTCDate(), date.getUTCHours(),
                    date.getUTCMinutes(), date.getUTCSeconds());
                  const timeIn = Math.abs(((now_utc - entryDate) / 1000) / 60);

                  return (
                    <ListItem key={`vehicle-item-${entryIndex}`} style={{display: 'flex', alignItems: 'center'}}>
                      <span style={{display: 'flex', flex: 1}}>{entry.vehicle.license_plate_no}</span>
                      <span style={{padding:"0 15px"}}>
                      {Math.floor(timeIn)}
                      &nbsp;mins.
                      </span>
                      <Button
                        onClick={() => {handleCheckOut(entry.vehicle.id);}}
                      >
                        Registar Salida
                      </Button>
                    </ListItem>
                  );
                })
              }
            </List>
          </Box>
        </VStack>
      </Card>
    </Center>
  );
};

export default Dashboard;