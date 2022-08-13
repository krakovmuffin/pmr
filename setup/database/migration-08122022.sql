-- doctors
CREATE TABLE doctors (
    pk INT GENERATED ALWAYS AS IDENTITY,

    name TEXT NOT NULL,

    email TEXT NULL DEFAULT NULL,
    phone TEXT NULL DEFAULT NULL,

    specialty TEXT NULL DEFAULT NULL,

    address_line TEXT NULL DEFAULT NULL,
    address_city TEXT NULL DEFAULT NULL,
    address_zip TEXT NULL DEFAULT NULL,
    address_state TEXT NULL DEFAULT NULL,
    address_country TEXT NULL DEFAULT NULL,

    note TEXT NULL DEFAULT NULL,

    PRIMARY KEY(pk)
);

-- doctors' specialties dictionary
CREATE TABLE dictionary_doctors_specialties (
    pk INT GENERATED ALWAYS AS IDENTITY,
    label TEXT NOT NULL,

    PRIMARY KEY(pk)
);

INSERT INTO dictionary_doctors_specialties
( label )
VALUES
('Anatomical Pathology'),
('Anesthesiology'),
('Cardiology'),
('Cardiovascular/Thoracic Surgery'),
('Clinical Immunology/Allergy'),
('Critical Care Medicine'),
('Dermatology'),
('Diagnostic Radiology'),
('Emergency Medicine'),
('Endocrinology and Metabolism'),
('Family Medicine'),
('Gastroenterology'),
('General Internal Medicine'),
('General Surgery'),
('General/Clinical Pathology'),
('Geriatric Medicine'),
('Hematology'),
('Medical Biochemistry'),
('Medical Genetics'),
('Medical Microbiology and Infectious Diseases'),
('Medical Oncology'),
('Nephrology'),
('Neurology'),
('Neurosurgery'),
('Nuclear Medicine'),
('Obstetrics/Gynecology'),
('Occupational Medicine'),
('Ophthalmology'),
('Orthopedic Surgery'),
('Otolaryngology'),
('Pediatrics'),
('Physical Medicine and Rehabilitation (PM & R)'),
('Plastic Surgery'),
('Psychiatry'),
('Public Health and Preventive Medicine (PhPm)'),
('Radiation Oncology'),
('Respirology'),
('Rheumatology'),
('Urology');
