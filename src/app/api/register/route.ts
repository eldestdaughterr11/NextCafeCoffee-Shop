import { NextRequest, NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function POST(req: NextRequest) {
  try {
    const { name, email, password } = await req.json();

    // Create user in database
    const user = await prisma.user.create({
      data: {
        name: name,
        username: email.split('@')[0], // Generate username from email
        email: email,
        password: password,
        role: 'customer'
      }
    });

    return NextResponse.json({ message: 'User registered successfully', user }, { status: 201 });
  } catch (error) {
    console.error('Registration Error:', error);
    return NextResponse.json({ error: 'User registration failed' }, { status: 500 });
  }
}
