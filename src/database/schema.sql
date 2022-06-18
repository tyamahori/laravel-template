CREATE TABLE "tyamahori"."failed_jobs" (
    "id" bigserial NOT NULL,
    "uuid" character varying(255) NOT NULL,
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY ("id")
);
ALTER TABLE tyamahori.failed_jobs ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);

CREATE TABLE "tyamahori"."migrations" (
    "id" serial NOT NULL,
    "migration" character varying(255) NOT NULL,
    "batch" integer NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "tyamahori"."password_resets" (
    "email" character varying(255) NOT NULL,
    "token" character varying(255) NOT NULL,
    "created_at" timestamp
);
CREATE INDEX password_resets_email_index ON tyamahori.password_resets USING btree (email);

CREATE TABLE "tyamahori"."personal_access_tokens" (
    "id" bigserial NOT NULL,
    "tokenable_type" character varying(255) NOT NULL,
    "tokenable_id" bigint NOT NULL,
    "name" character varying(255) NOT NULL,
    "token" character varying(64) NOT NULL,
    "abilities" text,
    "last_used_at" timestamp,
    "created_at" timestamp,
    "updated_at" timestamp,
    PRIMARY KEY ("id")
);
CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON tyamahori.personal_access_tokens USING btree (tokenable_type, tokenable_id);
ALTER TABLE tyamahori.personal_access_tokens ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);

CREATE TABLE "tyamahori"."users" (
    "id" bigserial NOT NULL,
    "name" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "email_verified_at" timestamp,
    "password" character varying(255) NOT NULL,
    "remember_token" character varying(100),
    "created_at" timestamp,
    "updated_at" timestamp,
    PRIMARY KEY ("id")
);
ALTER TABLE tyamahori.users ADD CONSTRAINT users_email_unique UNIQUE (email);
