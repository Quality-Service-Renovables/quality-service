import axios from 'axios';

// Configura la instancia de Axios
const apiClient = axios.create({
  baseURL: window.location.origin + '/api',
});

// Ejemplo de una función para obtener una inspección por UUID
export const getInspection = (inspectionUuid) => {
  return apiClient.get(`/inspections/${inspectionUuid}`);
};

export const getEvidences = (inspectionFormId) => {
  return apiClient.get('/inspection/forms/get-form-evidences/' + inspectionFormId);
};